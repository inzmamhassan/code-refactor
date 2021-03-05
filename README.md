## My Core Qaulity Beliefs

* Beautiful is better than ugly.
* Explicit is better than implicit. 
* Simple is better than complex. 
* Complex is better than complicated. 
* Flat is better than nested. 
* Sparse is better than dense. 
* Readability counts. 
* Special cases aren't special enough to break the rules. 
* Although practicality beats purity. 
* Errors should never pass silently. 
* Unless explicitly silenced. 
* In the face of ambiguity, refuse the temptation to guess. 
* There should be one-- and preferably only one --obvious way to do it. 
* Although that way may not be obvious at first unless you're Dutch. 
* Now is better than never. 
* Although never is often better than right now. 
* If the implementation is hard to explain, it's a bad idea. If the implementation is easy to explain, it may be a good idea.

## Laravel Qaulity Principles
* Horse for Corses (Seperation of concerns) Ideally Controller should be close to http controller with business logic coming from `Service Classes`.
* `Reuseable` global functions should be in `helpers.php`, 
* SOLID principles
* Use of Laravel notification system for notification. 
* Refector code into smaller chunks rather that a few monolithic files, ie 4000 lines controller is bad practic, 
* DB quries should be in Repositories and Modals. Personaly I use modal over Repositories.
* I am big fan of `php trats` which is similar to dependency injection in Java Spring or JS in general Make business logic trats ie. File.php deals with business logic with files management. 
* As for as code formating is concerned, I usually follow `PSR-2`, 
* I have no hard and fast rules on formating, my whole point is that whole team should one standard whatever it is,

## Code Review: 

* Code is lack of `single responsibility principle` and `Separation of Concerns`. 
* `BookingController` is handling multiple type queries ie. `booking`, `jobs`, and `notifications`. 
* There are a lot of `if` conditions being used which can be avoided using `Null coalescing`.
* converting `requests` to `array` and then check if a parameter set is bad, we can avoid this suitation using request build in functioins like `filled`.
* Use `early return` pattern instead using temporary veriables.
* Should use built in Laravel `Authorization` and `Gate`.
* Should use built in Laravel `validation`.
* Should use  built in Laravel `Notification`.
* We can use `service` classes of extra business logic.
* over the top use of `magic variables`. Avoid `env` calls outside of your config files. This can break code with `config caching`.
* I think we can use `Models` to make controller skinny and can use `Service Classes` for `business logic`. 
* I don't know app context but if we often need to change database `repository pattern` is ok.
* But Nevertheless the way code in `repository` is written very below par to say the least.
* whole `repository` should be written differently but due `shortage of time` I will only some parts as a proof of concept.
* I think it's better to use `guzzlehttp/guzzle` for reaching out to external API
* Some variables are defined but used as a return data immediately. Instead of `Early Return`. Considering php bad garbage collection this is bad practice.
* `API responses` are not following any standard pattern
* `Error handling` is not good
* Few things are not configurable and `hardcoded` in the code like the `logger path` in repository
* `Internationalizaing` is not handled correctly


