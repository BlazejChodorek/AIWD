Analysis and visualization of data
==============

A Symfony project created on October 5, 2017, 12:31 pm.

The application performs the following tasks:
- downloading data from .json file,
- pre-processing of data,
- statistical analysis,
- estimation,
- visualization of data.

The view after loading a file to the app. On the left there is a panel which enables switching among table with data, estimation and graph, whereas on the right side, data  concerning static analysis is displayed

![alt text](https://github.com/BlazejChodorek/aiwd/blob/master/screen1.png?raw=true)

Damaged records are marked with red and they were replaced by an average value which was generated basing on records that were not damaged

![alt text](https://github.com/BlazejChodorek/aiwd/blob/master/screen2.png?raw=true)

The app enables to generate any power of the engine if it fits in the certain interval. Acceleration is generated using linear regression equation. Moreover, in the left panel there is a converter with the input of engine's power and acceleration

![alt text](https://github.com/BlazejChodorek/aiwd/blob/master/screen3.png?raw=true)

Data that was generated is shows on graph together with a linear regression and displaced points that are marked with blue. The graph is generated dynamically basing on input data

![alt text](https://github.com/BlazejChodorek/aiwd/blob/master/screen4.png?raw=true)
