from array import *

t = array('i', [10, 20, 30, 40, 50])
for i in t:
    print(i)

#insert
print()
t.insert(1, 11)
for i in t:
    print(i)

#delete
print()
t.remove(11)
for i in t:
    print(i)

#search
print()
print(t.index(40))

#update
print()
t[0] = 11
for i in t:
    print(i)
