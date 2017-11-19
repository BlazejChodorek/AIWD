function LinearRegression(_context, _url) {
    this.context = _context;
    this.url = _url;
    this.xAxisTo = 750;
    this.yAxisTo = 360;
    this.gridSize = 15;
    this.shift = 45;
    this.pointSize = 2;
    this.numFontStyle = "bold 8px sans-serif";
    this.titlesOfAxesFontStyle = "bold 12px sans-serif";
    this.drawGrid = function (color) {

        //  linie pionowe
        for (var x = 0.5; x < this.xAxisTo; x += this.gridSize) {
            this.context.moveTo(x, 0);
            this.context.lineTo(x, this.yAxisTo);
        }
        //  linie poziome
        for (var y = 0.5; y < this.yAxisTo; y += this.gridSize) {
            this.context.moveTo(0, y);
            this.context.lineTo(this.xAxisTo, y);
        }
        this.context.strokeStyle = color;
        this.context.stroke();
    };
    this.drawAxes = function (color) {
        this.context.beginPath();
        //oś OX
        this.context.moveTo(0, this.shift);
        this.context.lineTo(this.xAxisTo, this.shift);
        //strzalka w prawo
        this.context.moveTo(this.xAxisTo - 5, 40);
        this.context.lineTo(this.xAxisTo, this.shift);
        this.context.lineTo(this.xAxisTo - 5, 50);

        //podziałka na OX
        for (var x = 60; x < this.xAxisTo; x += this.gridSize) {
            this.context.moveTo(x, 40);
            this.context.lineTo(x, 50);
        }

        //num OX
        this.context.font = this.numFontStyle;
        var num = 10;
        for (var x = 70; x < this.xAxisTo; x += this.gridSize * 2) {
            this.context.fillText(num, x, 38);
            if (num == 230) break;
            num += 10;
        }

        //num OY
        num = 1;
        for (var y = 64; y < this.xAxisTo; y += this.gridSize) {
            this.context.fillText(num, 25, y);
            if (num == 20) break;
            num++;
        }

        //oś OY
        this.context.moveTo(this.shift, 0);
        this.context.lineTo(this.shift, this.yAxisTo);
        //strzalka w dol
        this.context.moveTo(this.shift, this.yAxisTo);
        this.context.lineTo(40, this.yAxisTo - 5);
        this.context.moveTo(this.shift, this.yAxisTo);
        this.context.lineTo(50, this.yAxisTo - 5);

        //podziałka na OY
        for (var y = 60; y < this.yAxisTo; y += this.gridSize) {
            this.context.moveTo(40, y);
            this.context.lineTo(50, y);
        }

        this.context.fillText("(0, 0)", 25, 40);

        this.context.strokeStyle = color;
        this.context.stroke();
    };
    this.setTitlesOfAxes = function (xTitle, yTitle) {

        this.context.beginPath();
        this.context.font = this.titlesOfAxesFontStyle;
        this.context.fillText(xTitle, (this.xAxisTo - this.shift) / 2, this.shift / 2);

        var metric = this.context.measureText(yTitle);
        this.context.save();

        var tx = 35 + (metric.width / 2);
        var ty = 80 + 5;
        this.context.translate(tx, ty);
        this.context.rotate(Math.PI / -2);
        this.context.translate(-tx, -ty)
        this.context.fillText(yTitle, 15, 15);
        this.context.restore();

        this.context.strokeStyle = "#000000";
        this.context.stroke();
    };
    this.drawLinearRegression = function (lineColor, pointsColor) {
        var context = this.context;
        var shift = this.shift;
        var gridSize = this.gridSize;
        var pointSize = this.pointSize;

        $.ajax({
            url: this.url,
            data: null,
            type: "POST",
            async: true,
            ajaxContentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            ajaxProcessData: true,
            success: function (response) {

                drawPoints(response.enginePower, response.acceleration,
                    response.enginePowerQ1, response.enginePowerQ3,
                    response.accelerationQ1, response.accelerationQ3);
                drawlinearReg(response.a, response.b, response.norm.enginePowerFrom, response.norm.enginePowerTo);
            },
            error: function (response) {
            },
        });

        function drawlinearReg(a, b, from, to) {
            // Y = aX + b

            var x1 = from;
            var x2 = to;
            var y1 = a * x1 + b;
            var y2 = a * x2 + b;

            x1 = x1 * 3 + shift;
            x2 = x2 * 3 + shift;
            y1 = y1 * gridSize + shift;
            y2 = y2 * gridSize + shift;

            context.beginPath();

            context.moveTo(x1, y1);
            context.lineTo(x2, y2);

            context.strokeStyle = lineColor;
            context.stroke();
        }

        function drawPoints(enginesPower, accelerations, enginePowerQ1, enginePowerQ3, accelerationQ1, accelerationQ3) {

            var enginePowerIRQ = enginePowerQ3 - enginePowerQ1;
            var accelerationIRQ = accelerationQ3 - accelerationQ1;

            for (var i = 0; i < enginesPower.length; i++) {
                drawOnePoint(enginesPower[i], accelerations[i]);
            }

            function drawOnePoint(x, y) {

                context.beginPath();

                var cx = x * 3 + shift;
                var cy = y * gridSize + shift;
                context.save();
                context.beginPath();

                context.translate(cx - pointSize, cy - pointSize);
                context.scale(pointSize, pointSize);
                context.arc(1, 1, 1, 0, 2 * Math.PI, false);

                //Identyfikacja punktów oddalonych
                //xi < Q1 − 1, 5(IRQ)   ||   xi > Q3 + 1, 5(IRQ)
                if ((x < enginePowerQ1 - (1.5 * enginePowerIRQ)) || (x > enginePowerQ3 + (1.5 * enginePowerIRQ))) {
                    if ((y < accelerationQ1 - (1.5 * accelerationIRQ)) || (y > accelerationQ3 + (1.5 * accelerationIRQ))) {
                        context.strokeStyle = "#272dbb";
                    }
                } else {
                    context.strokeStyle = pointsColor;
                }

                context.stroke();
                context.restore();
            }
        }
    };

}