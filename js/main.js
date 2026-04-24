document.addEventListener("DOMContentLoaded", function () {
    document.body.classList.add("page-loaded");
    var menuToggle = document.getElementById("menuToggle");
    var mainNav = document.getElementById("mainNav");

    if (menuToggle && mainNav) {
        menuToggle.addEventListener("click", function () {
            mainNav.classList.toggle("open");
        });
    }

    setupSeatSelection();
    setupFaqAccordion();
    setupPageTransitions();
    setupStaticDemoForms();
});

function setupSeatSelection() {
    var bookingForm = document.getElementById("bookingForm");
    var seatButtons = document.querySelectorAll(".seat.available");
    var selectedSeatsInput = document.getElementById("selectedSeats");
    var selectedSeatsPreview = document.getElementById("selectedSeatsPreview");
    var ticketTotalPreview = document.getElementById("ticketTotalPreview");

    if (!bookingForm || seatButtons.length === 0 || !selectedSeatsInput) {
        return;
    }

    var adultInput = document.getElementById("adultTickets");
    var studentInput = document.getElementById("studentTickets");
    var childInput = document.getElementById("childTickets");

    var selectedSeats = [];

    function getTicketCount() {
        var adult = parseInt(adultInput.value || "0", 10);
        var student = parseInt(studentInput.value || "0", 10);
        var child = parseInt(childInput.value || "0", 10);
        return adult + student + child;
    }

    function updateTotalPreview() {
        var adult = parseInt(adultInput.value || "0", 10);
        var student = parseInt(studentInput.value || "0", 10);
        var child = parseInt(childInput.value || "0", 10);

        var adultPrice = parseFloat(bookingForm.dataset.adultPrice || "5");
        var studentPrice = parseFloat(bookingForm.dataset.studentPrice || "3.5");
        var childPrice = parseFloat(bookingForm.dataset.childPrice || "2.5");

        var total = adult * adultPrice + student * studentPrice + child * childPrice;
        ticketTotalPreview.textContent = "EUR " + total.toFixed(2);
    }

    function renderSelectedSeats() {
        selectedSeatsInput.value = selectedSeats.join(",");
        selectedSeatsPreview.textContent = selectedSeats.length ? selectedSeats.join(", ") : "None";
    }

    function enforceSeatLimit() {
        var maxSeats = getTicketCount();
        if (selectedSeats.length > maxSeats) {
            selectedSeats = selectedSeats.slice(0, maxSeats);
            seatButtons.forEach(function (button) {
                if (!selectedSeats.includes(button.dataset.seat)) {
                    button.classList.remove("selected");
                }
            });
            renderSelectedSeats();
        }
    }

    [adultInput, studentInput, childInput].forEach(function (input) {
        input.addEventListener("input", function () {
            enforceSeatLimit();
            updateTotalPreview();
        });
    });

    seatButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            var seatCode = button.dataset.seat;
            var maxSeats = getTicketCount();

            if (maxSeats === 0) {
                alert("Please choose ticket quantities first.");
                return;
            }

            if (button.classList.contains("selected")) {
                button.classList.remove("selected");
                selectedSeats = selectedSeats.filter(function (seat) {
                    return seat !== seatCode;
                });
            } else {
                if (selectedSeats.length >= maxSeats) {
                    alert("You cannot select more seats than total tickets.");
                    return;
                }
                button.classList.add("selected");
                selectedSeats.push(seatCode);
            }

            renderSelectedSeats();
        });
    });

    updateTotalPreview();
    renderSelectedSeats();
}

function setupFaqAccordion() {
    var questions = document.querySelectorAll(".faq-question");
    if (questions.length === 0) {
        return;
    }

    questions.forEach(function (button) {
        button.addEventListener("click", function () {
            var answer = button.nextElementSibling;
            if (!answer) {
                return;
            }

            answer.classList.toggle("open");
        });
    });
}

function setupPageTransitions() {
    var reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    if (reduceMotion) {
        return;
    }

    var links = document.querySelectorAll("a[href]");
    links.forEach(function (link) {
        link.addEventListener("click", function (event) {
            var href = link.getAttribute("href");
            var rel = (link.getAttribute("rel") || "").toLowerCase();

            if (event.defaultPrevented) {
                return;
            }
            if (event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
                return;
            }
            if (!href || href.charAt(0) === "#" || href.indexOf("javascript:") === 0) {
                return;
            }
            if (href.indexOf("mailto:") === 0 || href.indexOf("tel:") === 0) {
                return;
            }
            if (link.target === "_blank" || link.hasAttribute("download")) {
                return;
            }
            if (rel.indexOf("external") !== -1) {
                return;
            }
            if (link.closest("form")) {
                return;
            }

            var url = new URL(href, window.location.href);
            if (url.origin !== window.location.origin) {
                return;
            }
            if (url.pathname === window.location.pathname && url.search === window.location.search) {
                return;
            }

            event.preventDefault();
            document.body.classList.add("page-leaving");
            setTimeout(function () {
                window.location.href = url.href;
            }, 320);
        });
    });
}

function setupStaticDemoForms() {
    // Prevent frontend-only demo forms from posting to backend endpoints.
    var demoForms = document.querySelectorAll("form[data-static-demo='true']");
    demoForms.forEach(function (form) {
        form.addEventListener("submit", function (event) {
            event.preventDefault();
        });
    });
}
