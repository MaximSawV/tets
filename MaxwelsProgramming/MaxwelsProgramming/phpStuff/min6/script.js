function createGreeting () {
    let greeting;
    let today = new Date();
    let time = today.getHours();
    if (time <= 11) {
        greeting = ("Guten Morgen")
    }else if (time <= 17) {
        greeting = ("Guten Tag")
    }else if (time <= 23) {
        greeting = ("Guten Abend")
    }

    return greeting;
}


function createGreetingCover () {
    let cover = document.getElementById("cover");
    cover.style.height = window.innerHeight;
    cover.style.width = window.innerWidth;
    let greeting = createGreeting();
    let text = document.createElement("p");
    text.id = "coverText";
    text.innerHTML = (greeting)
    document.getElementById("cover").appendChild(text);
}

function decover (id) {
    let coverText = document.getElementById("coverText");
    coverText.remove();
    let elem = document.getElementById(id);
    let pos = window.innerHeight;
    let id2;
    clearInterval(id2);
    id2 = setInterval(frame, 1);
    function frame() {
        if (pos < 0) {
        clearInterval(id2);
        elem.remove();
        } else {
        pos-=20;
        elem.style.height = pos + 'px';
        }
    }
}

function setGreeting() {
    let greeting = createGreeting();
    document.getElementById("greeting2").innerHTML = (greeting);
}

function openMenu () {
    let elem = document.getElementById("head");
    let width = elem.style.width;
    let height = elem.style.height;
    let targetHeight = window.innerHeight;
    let menuOpen;
    clearInterval (menuOpen);
    menuOpen = setInterval(frame, 1);
    function frame () {
        if (width >= window.innerWidth) {
            clearInterval(menuOpen);
        } else {
            width += 1;
            elem.style.width = width + 'px'
        }

        if (height >= targetHeight) {
            clearInterval(menuOpen);
        } else {
            height += 1;
            elem.style.height = height + 'px'
        }
    }
    document.getElementById("menu").style.display = "flex";
}