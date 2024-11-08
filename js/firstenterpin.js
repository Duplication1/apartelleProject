function moveToNext(current) {
    if (current.value.length === 1 && current.nextElementSibling) {
        current.nextElementSibling.focus();
    }
}

function handleKeyNavigation(event, current) {
    if (event.key === "Backspace" && current.value === '' && current.previousElementSibling) {
        current.previousElementSibling.focus();
        current.previousElementSibling.value = ''; 
    } else if (event.key === "ArrowLeft" && current.previousElementSibling) {
        current.previousElementSibling.focus();
    } else if (event.key === "ArrowRight" && current.nextElementSibling) {
        current.nextElementSibling.focus();
    }
}