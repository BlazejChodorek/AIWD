$(document).ready(function () {

    var c_canvas = document.getElementById("c");
    var context = c_canvas.getContext("2d");

    drawGrid(context, "#dbdbdb");
    drawAxes(context, "black");
    setTitlesOfAxes(context, "moc silnika", "przysp")

    drawLinearRegression(context, 0.2, 46.8, "black");

    var enginesPower = [100, 150, 160, 170];
    var accelerations = [40, 60, 10, 15];

    drawPoints(context, enginesPower, accelerations);

});

function drawLinearRegression(context, a, b, color) {
    //Y = aX + b
    //a = -0.2
    //b = 46.8

    var x1 = 40;
    var x2 = 650;
    var y1 = a * x1 + b;
    var y2 = a * x2 + b;

    context.beginPath();

    if (y1 > 0 && y2 > 0) {
        context.moveTo(x1, y1);
        context.lineTo(x2, y2);
    } else {
        console.log("drawLinearRegression error");
        context.moveTo(x1, y1);
        context.lineTo(x2, y2);
    }

    context.strokeStyle = color;
    context.stroke();
}

function drawPoints(context, enginesPower, accelerations) {

    for (var i = 0; i < enginesPower.length; i++) {
        drawOnePoint(context, enginesPower[i], accelerations[i]);
    }
}

function drawOnePoint(context, x, y) {
    context.beginPath();

    var size = 3;
    var shift = 40;
    var cx = x + shift;
    var cy = y * 2 + shift;
    context.save();
    context.beginPath();

    context.translate(cx - size, cy - size);
    context.scale(size, size);
    context.arc(1, 1, 1, 0, 2 * Math.PI, false);

    context.strokeStyle = "#000000";
    context.stroke();
    context.restore();
}

function drawGrid(context, color) {
    //  linie pionowe
    for (var x = 0.5; x < 650; x += 10) {
        context.moveTo(x, 0);
        context.lineTo(x, 375);
    }
    //  linie poziome
    for (var y = 0.5; y < 375; y += 10) {
        context.moveTo(0, y);
        context.lineTo(650, y);
    }

    context.strokeStyle = color;
    context.stroke();
}

function drawAxes(context, color) {
    context.beginPath();
    //OX
    context.moveTo(0, 40);
    context.lineTo(650, 40);
    //strzalka w prawo
    context.moveTo(645, 35);
    context.lineTo(650, 40);
    context.lineTo(645, 45);

    //OY
    context.moveTo(40, 0);
    context.lineTo(40, 375);
    //strzalka w dol
    context.moveTo(45, 370);
    context.lineTo(40, 375);
    context.lineTo(35, 370);

    context.font = "bold 12px sans-serif";
    context.fillText("(0, 0)", 5, 30);

    context.strokeStyle = color;
    context.stroke();
}

function setTitlesOfAxes(context, xTitle, yTitle) {
    context.beginPath();
    context.font = "bold 12px sans-serif";
    context.fillText(xTitle, 300, 30);
    context.fillText(yTitle, 0, 165);
    context.strokeStyle = "#000000";
    context.stroke();
}