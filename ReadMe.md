# Barber shop booking website
This website has two main pages: 

* The first one is for the client. It is a front-end page that allows anyone to book an appointment with the desired barber (or any) at the desired time. 
You can check it out at the following address: https://demo-barbershop-by-amaury.com
I encourage anyone trying out the website to book an ppointment with their real email address (you will receive the notifications of your booking on it).

* The second one is for the manager of the store. It allows the manager of the store to manage the schedule of his employees (working days, breaks etc..), 
but also to manage to manage the appointments, the services offered (price, time, category etc ....) visible on the main page. 
The admin can update any informations including password (please don't change the password), and he employees have also access to their personal schedule for the week.
You can check it out at the following address: https://demo-barbershop-by-amaury.com/barber-admin
With the following credentials:
username: amaury
password: 1212

Please contact me at deguillebon.amaury@gmail.com if you would like to have the full repo.

# Special features
Please take into account that this work could not have been possible without the following source: https://github.com/jairiidriss/barbershop-website-php-mysql on which my work is based. 
Here is a list of the features I added from the original content:
* Some loading screens have been added to smooth the user experience (especially after booking, which can be confusing if for a few secodns the client has an empty page).
* Possibility to choose "Any" instead of having to choose one barber, thus allowing to show all availibilities to the client.
* When booking, the client will receive notifications on his email address (that he will have to activate at the first booking for scurity purposes).
* The clients are able to cancel their appointment up to one day in advance.
* The employees can have access to their schedule.
* The manager has a "profile" page in which he can update his informations including his password (once again please don't do that).
* The SQL daatbase has been updated for an easier experience and better latency.
* Some security features have been added (time out session in the admin page, verification of emails, encrypted informations ...).

