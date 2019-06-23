function setup() {
  var can = createCanvas(300, 200);
    can.parent('Attendance');
  frameRate(240);
  findxy();
  console.log(xs);
  console.log(ys);
  
  x1 = xs[1];
  y1 = ys[1];
  x2 = xs[2];
  y2 = ys[2];
  tempX = x1;
  tempY = y1;
}

var x1 = 0;
var y1 = 0;
var x2 = 0;
var y2 = 0;
var count = 1;
var presents = [4, 7, 6, 8, 9, 5, 2, 5];
var tempX = 0;
var tempY = 0;
var xs = [0,0,0,0,0,0,0,0,0];
var ys = [0,0,0,0,0,0,0,0,0];
var colors = ['#9c27b0', '#e91e63', '#f44336', '#673ab7', '#2196f3', '#009688', '#424242', '#4caf50', '#fb8c00'];


function draw() {
  background(255);
  stroke('#3f51b5ff');
  fill('#3f51b5ff');
  strokeWeight(3);
  
  console.log(x2, y2);
  console.log(tempX);
  if(count<=8) {
    if (tempX <= x2){
    line(x1, y1, tempX, tempY); 
    tempX = tempX + (x2-x1)/20; 
    tempY += (y2-y1)/20;
    
  } else {
    x1 = x2;
    y1 = y2; 
    count++;
    x2 = xs[count+1];
    y2 = ys[count+1];
    tempX = x1;
    tempY = y1;
  }
  
  }
  
  
  for(i = 1; i < count ; i++) {
    
    line(xs[i], ys[i] , xs[i+1], ys[i+1]);
  }
  
  for(i=1; i< count;i++) {
    stroke(colors[i]);
    fill(colors[i]);
    circle(xs[i], ys[i], 4);
  }
  
  if(count>=8) {
    textSize(12);
    fill('black');
    strokeWeight(0.1);
    text('Sem 1',20,120);
    text('15%',60,120);
    
    
    text('Sem 2',20,140);
    text('25%',60,140);
    
    text('Sem 3',70,160);
    text('35%',70+40,160);
    
    text('Sem 4',70,180);
    text('20%',70+40,180);
    
    text('Sem 5',70+50,120);
    text('5%',70+50+40,120);
    
    text('Sem 6',70+50,140);
    text('60%',70+50+40,140);
    
    text('Sem 7',70+100,140+20);   
    text('80%',70+100+40,140+20);
    
    text('Sem 8',70+100,140+20+20);    
    text('55%',70+100+40,140+20+20);
    
  }
}

function findxy() {
  for(i =0; i<=8; i++) {
    if(i==0) {
      xs[i]=0;
    } else { 
      xs[i] = xs[i-1] + 30;
      ys[i] = presents[i-1] * 10;
    }
    
  }
}