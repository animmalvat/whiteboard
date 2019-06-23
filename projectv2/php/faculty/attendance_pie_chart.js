function setup() {
    var can = createCanvas(300, 300);
    can.parent('Attendance');
    textSize(32);

    frameRate(60);
}
var x = 1.0001;
var start = 0;
var pX = 0;
radius = 0;

function draw() {
    if (start == 1) {
        background('rgba(0,0,0,0)');
        clear();
        stroke(0);
        strokeWeight(0.1);
        fill(0);
        text(int(pX) + "%", 75 + 55, 75 + 20);
        stroke('#3f51b5ff');
        strokeWeight(4);
        fill('rgba(0,0,0,0)');

        if (x <= (1.33 * pX / 100) + 1) {
            x += 0.01;
        }
        if (radius < 10) {
            radius += 0.25;
        }
        arc(75 + 80, 75 + 10, 150, 150, 3 * PI / 2, x * 3 * PI / 2);
        findPoint(150 / 2, x * 3 * PI / 2, radius);
    } else {
        console.log('yet to load');
    }



}

function startDrawing(percent) {
    start = 1;
    pX = percent;
    console.log('now we can start drawing the pie chart');

}

function findPoint(radius, angle, r) {
    var x = Math.sin(angle) * radius;
    var y = Math.cos(angle) * radius;
    fill('#3f51b5ff')
    circle(y + 75 + 80, x + 75 + 10, r);
}
