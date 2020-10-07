# Countdown Timer

Website to display a countdown timer to a specified date.

## Table of Contents

* [Create a countdown using the UI](#create-a-countdown-using-the-ui)
* [Create a countdown by passing url parameters](#create-a-countdown-by-passing-url-parameters)
* [Screenshots](#screenshots)
* [Contributing](#contributing)

## Create a countdown using the UI

View the demo at http://eyl327.mywebcommunity.org/countdown/

## Create a countdown by passing url parameters

Fields:

* **d** - date and time in the format "YYYYMMDDTHHmm" (ex. 20201231T1300 for 31st of December, 2020 at 1 pm.)
* **tz** - timezone offset from UTC (ex. -7 for MST)
* **msg** - message to display above the countdown (ex. "Countdown to Deadline")
* **font** - a font available from [fonts.google.com](https://fonts.google.com/) (ex. "Roboto")
* **bg** - background image url (ex. https://i.imgur.com/HcD6od4.jpg) or hex code preceded by %23 (ex. %23111111 for #111111)

Example:

[http://eyl327.mywebcommunity.org/countdown/?d=20201231T2359&tz=%2B3&msg=New%20Year%27s%20Eve&font=Righteous&bg=https%3A%2F%2Fi.imgur.com%2FHcD6od4.jpg](http://eyl327.mywebcommunity.org/countdown/?d=20201231T2359&tz=%2B3&msg=New%20Year%27s%20Eve&font=Righteous&bg=https%3A%2F%2Fi.imgur.com%2FHcD6od4.jpg)

## Screenshots

![Create a Countdown](https://i.imgur.com/kvWT0YE.png)

![Countdown 1](https://i.imgur.com/BOiMUce.png)

![Countdown 2](https://i.imgur.com/VNnadBY.png)

![Countdown 3](https://i.imgur.com/0qjR34X.png)

## Contributing

**Video tutorial: [How to make a Pull Request with Github Desktop](https://youtu.be/mMSOIkkSIag)**

1. Fork this repository and clone your repo to your computer

> `git fork https://github.com/DenverCoder1/countdown.git`

2. Create a new branch

> `git checkout -b new_branch` (where `new_branch` is the feature you are working on)

3. Set up a local or hosted web server to test your code

> [This can be done with XAMPP](https://youtu.be/K-qXW9ymeYQ)

4. Make your changes to the code

5. When it is ready, submit a PR from your forked repository