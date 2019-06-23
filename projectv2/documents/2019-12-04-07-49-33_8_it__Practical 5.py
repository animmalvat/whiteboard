included = [False, False, False]
chosen = []
sample = [5,10,12]
M = 30
s = [5,10,12]
inc = {}
inc['5'] = False
inc['10'] = False
inc['12'] = False

def sum(sample, included):
    answer = 0
    for i in range(0, int(len(sample))):
        if(included[i]):
            answer += sample[i]
        else:
            pass
    return answer

def reinstantiate(included):
    for i in included:
        i = False

calls = 0

def p(s, i):
    print('{', end="");
    for i1 in range(0, int(len(s))):
        if(i[i1]):
            print(s[i1], end=",")
    print('}', end="")
    print()

def sumOfSubsets(sample, included):
    
    global s
    global inc
    
    if not sample:
        print(chosen)
        
        
    else:
        #choose a number
        for i in range(0, int(len(sample))):
            chosen.append(sample[i])
            temp = sample[i]
            sample.remove(sample[i])
                
            #explore
            sumOfSubsets(sample, included)

            #uncheck
            
            sample.insert(i, temp)
            chosen.remove(sample[i])
    
    

sumOfSubsets(sample, included)



