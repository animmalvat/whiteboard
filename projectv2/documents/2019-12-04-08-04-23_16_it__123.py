import gym
import universe

env = gym.make('flashgames.CoasterRacer-v0')
obs = env.reset()

while True:
    a = [[('KeyEvent', 'ArrowUp', True)] for o in obs]
    obs, reward, done, info = env.step(a)
    env.render()
