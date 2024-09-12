/* Make sections appear and disappear when scrolling into view */

const sections = document.querySelectorAll('section');

const revealSections = (scrollTop) => {
    sections.forEach(section => {
        if (scrollTop + window.innerHeight > section.offsetTop + section.offsetHeight / 4) {
            section.classList.remove('hide');
            section.classList.add('reveal');
        } else {
            if (!section.classList.contains('no-hide-effect')) {
                section.classList.remove('reveal');
                section.classList.add('hide');
            }
        }
    })
}

revealSections(0);

window.addEventListener('scroll', () => {
    const scrollTop = window.scrollY;
    revealSections(scrollTop);
})

/* Adjust scroll height of internal links to have a distance of an 1/8th from the top */

document.querySelectorAll('.internal-link').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);

        if (targetElement) {
            const viewportHeight = window.innerHeight;
            const targetTop = targetElement.getBoundingClientRect().top;
            let offset = targetTop - (viewportHeight / 8) + window.scrollY;

            if (targetTop - viewportHeight > 10)
                offset = targetTop + window.scrollY;

            window.scrollTo({
                top: offset,
                behavior: 'smooth'
            });
        }
    });
});

/* Form validation - fields cannot be blank */

let submit = document.querySelector('button[type="submit"]');
let fields = document.querySelectorAll('input, textarea');

if (document.URL.includes("login.html") || document.URL.includes("addEntry.php")) {
    submit.addEventListener('click', validateFields);
}

let fieldsValid = false;

function validateFields(e) {
    if (fields[0].value === "" || fields[1].value === "") {
        alert("Please fill in all the fields");
        for (let field of fields) {
            if (field.value === "") {
                e.preventDefault();
                field.style.border = "0.15rem solid red";
            } else {
                field.style.border = "dashed white 0.1rem";
            }
        }
        fieldsValid = false;
    } else {
        fieldsValid = true;
    }
}

/* Form validation - confirmation dialog when resetting form contents */

if (document.URL.includes("addEntry.php")) {
    let reset = document.querySelector('button[type="reset"]');

    reset.addEventListener('click', function (e) {
        if (!confirm("Are you sure you want to clear the form?")) {
            e.preventDefault();
        }
        fields.forEach(field => {
            field.style.border = "dashed white 0.1rem";
        });
    });
}

/* Preview post layout */

if (document.URL.includes("addEntry.php")) {
    let preview = document.getElementById('preview');
    preview.addEventListener('click', validateFields);

    preview.addEventListener('click', function (e) {
        e.preventDefault();
        if (!fieldsValid) {
            return;
        }
        localStorage.setItem('title', document.getElementById('title').value);
        localStorage.setItem('content', document.getElementById('content').value);
        window.location.href = "preview.html";
    });
}

/* Display preview form */

function displayPreview() {
    let previewForm = document.getElementById('preview-form');
    let previewFormSection = document.getElementById('preview-form-section');
    let div = document.createElement('div');
    div.classList.add('post-header');

    let h4 = document.createElement('h4');
    h4.textContent = localStorage.getItem('title');
    h4.id = 'post-title';
    h4.style.whiteSpace = 'pre-wrap';

    let h2 = document.createElement('h2');
    h2.textContent = String.fromCodePoint(128338) + " " + getCurrentDate();
    h2.id = 'post-date';
    h2.style.whiteSpace = 'pre-wrap';

    let p = document.createElement('p');
    p.textContent = localStorage.getItem('content');
    p.id = 'post-content';
    p.style.whiteSpace = 'pre-wrap';

    div.appendChild(h4);
    div.appendChild(h2);
    previewFormSection.appendChild(div);
    previewFormSection.appendChild(document.createElement('hr'));
    previewFormSection.appendChild(p);

    let submitPost = document.createElement('button');
    submitPost.textContent = "Post";
    submitPost.type = 'submit';
    submitPost.id = 'submit';

    let cancelPost = document.createElement('button');
    cancelPost.textContent = "Edit";
    cancelPost.id = 'cancel-post';

    let inputTitle = document.createElement('input');
    inputTitle.type = 'hidden';
    inputTitle.name = 'title';
    inputTitle.value = localStorage.getItem('title');
    let inputContent = document.createElement('input');
    inputContent.type = 'hidden';
    inputContent.name = 'content';
    inputContent.value = localStorage.getItem('content');

    previewForm.appendChild(inputTitle);
    previewForm.appendChild(inputContent);

    let buttonsDiv = document.createElement('div');
    buttonsDiv.classList.add('buttons');
    buttonsDiv.appendChild(submitPost);
    buttonsDiv.appendChild(cancelPost);

    previewFormSection.appendChild(buttonsDiv);
    previewForm.appendChild(previewFormSection);
}

if (document.URL.includes("preview.html")) {
    displayPreview();

/* Go back if edit button pressed */

    let cancelPost = document.getElementById('cancel-post');
    cancelPost.addEventListener('click', function (e) {
        e.preventDefault();
        window.location.href = "addEntry.php";
    });

    document.getElementById('submit').addEventListener('click', function () {
        localStorage.removeItem('title');
        localStorage.removeItem('content');
    });
}

/* Restore form data if it's contained in localStorage */

if (document.URL.includes("addEntry.php")) {
    if ((localStorage.getItem('title') !== null) && (localStorage.getItem('content') !== null)) {
        document.getElementById('title').value = localStorage.getItem('title');
        document.getElementById('content').value = localStorage.getItem('content');
        localStorage.removeItem('title');
        localStorage.removeItem('content');
    }
}

/* Get current date in format 1st January 2021 20:21 UTC */

function getCurrentDate() {
    let dateUTC = new Date();
    let date = new Date(dateUTC.getTime() + (60 * 60 * 1000));
    let day = date.getDate();
    let end = "";

    if (day === 1 || day === 21 || day === 31) {
        end = "st";
    } else if (day === 2 || day === 22) {
        end = "nd";
    } else if (day === 3 || day === 23) {
        end = "rd";
    } else {
        end = "th";
    }

    return day + end + " " + date.toLocaleString('default', {month: 'long'}) + " " + date.getFullYear() + " " + ('0'+date.getUTCHours()).slice(-2) + ":" + ('0'+date.getUTCMinutes()).slice(-2) + " UTC";
}