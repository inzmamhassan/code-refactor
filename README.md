# code-refactorVSReview

My Core Qaulity Beliefs:

Beautiful is better than ugly. 
Explicit is better than implicit. 
Simple is better than complex. 
Complex is better than complicated. 
Flat is better than nested. 
Sparse is better than dense. 
Readability counts. 
Special cases aren't special enough to break the rules. 
Although practicality beats purity. 
Errors should never pass silently. 
Unless explicitly silenced. 
In the face of ambiguity, refuse the temptation to guess. 
There should be one-- and preferably only one --obvious way to do it. 
Although that way may not be obvious at first unless you're Dutch. 
Now is better than never. 
Although never is often better than right now. 
If the implementation is hard to explain, it's a bad idea. If the implementation is easy to explain, it may be a good idea.

Code Review: 

Code is lack of single responsibility principle. BookingController is handling a lot of logic related to booking, jobs, and notifications.
There are a lot of if conditions being used which can be avoided.
converting requests to array and then check if a parameter set is bad, we can avoid this suitation using request build in functioins like filled.
There are a lot of temporary veriables being used which can be avoided too by using early return pattern.
Use of built in Laravel Authorization and Gate system is missing.
Use of built in Laravel validation system is missing.
Use of built in Laravel Notification system is missing.
We can use service classes of extra business logic which polluting our repository class.
Direct use of .env variable is dangerous. Avoid env calls outside of your config files. This can break your code with config caching. Once the configuration has been cached, the .env file will not be loaded and all calls to the env function will return null.
And finally I don't think we need repository pattern here. I think we can use models to make controller skinny and can use service classes for business logic. I don't know app actual context but if we often need to change database repository pattern is good.

A good code in Laravel is the code which follow all the laravel recommended practices.
Practice SOLID principles, specially Single responsibility principe.
Use service class for extra business logic.
Use of Laravel notification system for notification.

