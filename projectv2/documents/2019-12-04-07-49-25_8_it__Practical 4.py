p = [10, 5, 15, 7, 6, 18, 3]
w = [2, 3, 5, 7, 1, 4, 1]
pw = []
weight = 0
sol = 0
limit = 15
#creating a dataset that can be used to check
def findPW(p, w) :
    for i in range(0, len(p)) :
       pw.append(p[i]/w[i]);
       
#function to find if the x is feasible or not
def f(x):
    y1 = max(pw)
    global sol
    global w
    global weight
    y = pw.index(y1);
    wei = w[y]
    print(y1);
    print(y);
    y = p[y]
    print(y);
    
    if(weight+wei <= 15) :
        weight+=wei
        sol+=y
        pw.remove(y1)
        

findPW(p,w)
for i in pw:
    f(pw);

print(sol);
    
    
