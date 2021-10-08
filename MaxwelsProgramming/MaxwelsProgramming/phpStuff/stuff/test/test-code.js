let xloc = 0;
let yloc = 0;
let xstep = 1;
let ystep = 0
var deg = 0;
var color = 0;
function movement (id) {
    var obj = document.getElementById(id);
    var degstr = deg + "deg"
    obj.style.transform = "rotate("+degstr+")";
    if(deg == 360){
        deg = 0;
    }


    if(xloc > window.innerWidth-100 && yloc == 0){
        newObj(xloc, yloc, xstep, ystep, id, obj.style.getPropertyValue("background"));
        xstep = 0;
        ystep = 1;
    }
     if(xloc > window.innerWidth-100 && yloc > window.innerHeight -100){
         newObj(xloc, yloc, xstep, ystep, id, obj.style.getPropertyValue("background"));
        xstep = -1;
        ystep = 0;
    }
    if(xloc == 0 && yloc > window.innerHeight - 100){
        newObj(xloc, yloc, xstep, ystep, id, obj.style.getPropertyValue("background"));
        xstep = 0;
        ystep = -1;
    }
    if(xloc == 0 && yloc == 0){
        newObj(xloc, yloc, xstep, ystep, id, obj.style.getPropertyValue("background"));
        xstep = 1;
        ystep = 0;
    }


    xloc += xstep;
    yloc += ystep;
    deg += 1

    obj.style.left = xloc +"px";
    obj.style.top = yloc + "px";
    
    /* for (let index = 0; index < 3; index++) {
      document.getElementById(id).style.left = speed +"px";
      speed += 200;
        
    } */
}


var color2 = 0;
var color3 = 0;
var colorstep = 1
function setcolor(id){
    if(color != 255){
        color +=colorstep;
    }
    if(color == 255 && color2 != 255){
        color2 += colorstep;
        if(color2 == 0){
            color -= 1;
        }
    }
    if(color2 == 255 &&  color3 != 255){
        color3 += colorstep;
        if(color3 == 0){
            color2 -= 1;
        }
    }

    if(color3 ==255){
    colorstep = -1;
    color3 = 244;
    }

    if(color == 0 && colorstep == -1){
        colorstep = 1;
    }
    document.getElementById(id).style.background = "rgb(" +color + ","+ color2 + "," + color3 +")";
}

function newObj(xloc, yloc, xstep, ystep, id, color){
    var newObject = document.createElement("div");
    newObject.style.height = "100px";
    newObject.style.background = color;
    newObject.style.width = "100px";
    newObject.style.position = "fixed";
    newObject.style.left = xloc + "px";
    newObject.style.top = yloc + "px";
    document.body.insertBefore(newObject, document.getElementById(id));
    var interval_newObj;
    interval_newObj = setInterval(move_newObj, 1, newObject, xstep, ystep, interval_newObj);
    console.log(interval_newObj);



    


}

function move_newObj(obj, xstep, ystep, interval_newObj){
    var xpos = parseInt(obj.style.left.replace("px", ""), 10) - xstep;
    var ypos = parseInt(obj.style.top.replace("px", ""), 10) - ystep;
    obj.style.left = xpos + "px";
    obj.style.top = ypos + "px";

    if(xpos < 0){
        obj.remove();
        clearInterval(interval_newObj);
    }
    if(xpos > window.innerWidth){
        obj.remove();
        clearInterval(interval_newObj);
    }
    if(ypos < 0){
        obj.remove();
        clearInterval(interval_newObj);
    }
    if(ypos > window.innerHeight){
        obj.remove();
        clearInterval(interval_newObj);
    }

}



    let interval;
    let interval2;
function move (id) {
    interval = setInterval(movement, 1, id);
    interval2 = setInterval(setcolor, 5, id)

}

function stop() {
    clearInterval(interval);
    clearInterval(interval2);
}