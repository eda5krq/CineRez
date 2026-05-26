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
    setupAjaxReservationCancel();
    setupTvmazeSearch();
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

    var selectedSeats = selectedSeatsInput.value
        ? selectedSeatsInput.value.split(",").filter(Boolean)
        : [];

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
        if (selectedSeats.includes(button.dataset.seat)) {
            button.classList.add("selected");
        }

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

function setupAjaxReservationCancel() {
    var buttons = document.querySelectorAll(".js-cancel-reservation");
    var messageBox = document.getElementById("ajaxMessage");

    if (buttons.length === 0) {
        return;
    }

    function showMessage(message, isSuccess) {
        if (!messageBox) {
            alert(message);
            return;
        }

        messageBox.textContent = message;
        messageBox.className = "ajax-message alert " + (isSuccess ? "success" : "error");
    }

    buttons.forEach(function (button) {
        button.addEventListener("click", function () {
            var reservationId = button.dataset.reservationId;
            var endpoint = button.dataset.endpoint || "ajax/delete-reservation.php";

            if (!reservationId) {
                showMessage("Missing reservation id.", false);
                return;
            }

            if (!window.confirm("Cancel this reservation?")) {
                return;
            }

            button.disabled = true;

            fetch(endpoint, {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "Accept": "application/json"
                },
                body: new URLSearchParams({ reservation_id: reservationId }).toString()
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    showMessage(data.message || "Reservation updated.", !!data.success);

                    if (!data.success) {
                        button.disabled = false;
                        return;
                    }

                    var row = document.getElementById("reservation-row-" + reservationId);
                    if (row) {
                        row.classList.add("reservation-cancelled");
                        var statusCell = row.querySelector(".js-reservation-status");
                        if (statusCell) {
                            statusCell.innerHTML = '<span class="status-badge status-cancelled">Cancelled</span>';
                        }
                    }

                    button.remove();
                })
                .catch(function () {
                    showMessage("Reservation could not be cancelled.", false);
                    button.disabled = false;
                });
        });
    });
}

function setupTvmazeSearch() {
    var form = document.getElementById("tvmazeSearchForm");
    var input = document.getElementById("tvmazeSearchInput");
    var results = document.getElementById("tvmazeResults");
    var status = document.getElementById("tvmazeSearchStatus");

    if (!form || !input || !results) {
        return;
    }

    function setStatus(message) {
        if (status) {
            status.textContent = message;
        }
    }

    function stripHtml(html) {
        var element = document.createElement("div");
        element.innerHTML = html || "";
        return element.textContent || element.innerText || "";
    }

    function addText(parent, tagName, text, className) {
        var element = document.createElement(tagName);
        element.textContent = text;
        if (className) {
            element.className = className;
        }
        parent.appendChild(element);
        return element;
    }

    function renderShows(items) {
        results.innerHTML = "";

        if (!items.length) {
            setStatus("No TVMaze results found.");
            return;
        }

        setStatus(items.length + " result" + (items.length === 1 ? "" : "s") + " found.");

        items.forEach(function (item) {
            var show = item.show || {};
            var card = document.createElement("article");
            card.className = "glass api-card";

            if (show.image && show.image.medium) {
                var image = document.createElement("img");
                image.src = show.image.medium;
                image.alt = (show.name || "TVMaze show") + " poster";
                card.appendChild(image);
            }

            addText(card, "h3", show.name || "Untitled show");

            var metaParts = [];
            if (show.premiered) {
                metaParts.push("Premiered: " + show.premiered.substring(0, 4));
            }
            if (show.rating && show.rating.average) {
                metaParts.push("Rating: " + show.rating.average);
            }
            if (metaParts.length) {
                addText(card, "p", metaParts.join(" | "), "small-muted");
            }

            addText(card, "p", stripHtml(show.summary) || "No summary available.");
            results.appendChild(card);
        });
    }

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        var query = input.value.trim();
        if (!query) {
            setStatus("Enter a show name to search.");
            return;
        }

        setStatus("Searching TVMaze...");
        results.innerHTML = "";

        fetch("https://api.tvmaze.com/search/shows?q=" + encodeURIComponent(query))
            .then(function (response) {
                if (!response.ok) {
                    throw new Error("TVMaze request failed.");
                }
                return response.json();
            })
            .then(renderShows)
            .catch(function () {
                setStatus("TVMaze search failed. Check your internet connection and try again.");
            });
    });
}
