document.addEventListener('DOMContentLoaded', () => {
    const toggleButton = document.getElementById('toggleButton');
    const secondNav = document.querySelector('.second-side-nav');
    const sideNavButtons = document.querySelectorAll('.side-nav-button');
    const sideNav = document.querySelector('.side-nav');
    // Toggle the second navigation on button click
    toggleButton.addEventListener('click', () => {
        secondNav.classList.toggle('open');
        if (secondNav.classList.contains('open')) {
            secondNav.style.display = 'flex'; 
        } else {
            secondNav.style.display = 'none'; 
        }
    });

    // Keep secondNav open on hover
    sideNav.addEventListener('mouseenter', () => {
        secondNav.style.display = 'flex'; // Keep it visible on hover
    });
    
    secondNav.addEventListener('mouseleave', () => {
        if (!secondNav.classList.contains('open')) {
            secondNav.style.display = 'none'; // Hide it if not open
        }
    });

    // Populate the second navigation based on button click
    sideNavButtons.forEach(button => {
        button.addEventListener('click', () => {
            const content = button.getAttribute('data-content');
            secondNav.innerHTML = content;
        });
    });
});
function highlightButton(button) {
    // Remove highlight from all buttons
    const buttons = document.querySelectorAll('.side-nav-button');
    buttons.forEach(btn => {
        btn.classList.remove('highlight');
    });

    // Highlight the clicked button
    button.classList.add('highlight');
}

function highlightSecondNav(button) {
    // Remove highlight from all second-nav-buttons
    const buttons = document.querySelectorAll('.second-nav-button');
    buttons.forEach(btn => {
        btn.classList.remove('highlight');
    });

    // Highlight the clicked second-nav-button
    button.classList.add('highlight');
}



const links = document.querySelectorAll('.stocklevel ul li a');

    // Loop through each link
    links.forEach(link => {
        link.addEventListener('click', function() {
            // Remove 'active' class from all links
            links.forEach(link => link.classList.remove('active'));

            // Add 'active' class to the clicked link
            this.classList.add('active');
        });
    });

/*dropdown */

// Toggle the dropdown menu when the profile button is clicked
document.getElementById('profileButton').addEventListener('click', function (event) {
    event.stopPropagation(); // Prevent click from bubbling up
    document.getElementById('dropdownMenu').classList.toggle('show');
});

// Close the dropdown if the user clicks outside of it
window.addEventListener('click', function (event) {
    const dropdown = document.getElementById('dropdownMenu');
    // Check if the dropdown is currently shown and if the click is not on the profile button or dropdown
    if (dropdown.classList.contains('show') && 
        event.target !== document.getElementById('profileButton') && 
        event.target !== dropdown) {
        dropdown.classList.remove('show');
    }
});


function filterItems(filterType) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "inventoryManagement/fetch_stock_levels.php", true); // Send request to the same page
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Replace the inner HTML of the inventory table with the response
            document.getElementById("inventoryTable").innerHTML = xhr.responseText;
        }
    };
    xhr.send("filter=" + filterType); // Send the filter type to the server
}


function loadPHP(button) {
    var file = button.getAttribute('data-file');
    if (file) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", file, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("result").innerHTML = xhr.responseText;
                history.pushState(null, '', '?file=' + encodeURIComponent(file));
            }
        };
        xhr.send();
    }
}
window.onload = function() {
    const params = new URLSearchParams(window.location.search);
    const file = params.get('file');
    if (file) {
        loadPHP({ getAttribute: () => decodeURIComponent(file) });
    }
};


