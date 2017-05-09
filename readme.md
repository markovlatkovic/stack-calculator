## Stack Calculator
[![Build Status](https://travis-ci.org/jeroennoten/stack-calculator.svg?branch=master)](https://travis-ci.org/jeroennoten/stack-calculator)

An implementation of a stack calculator via HTTP endpoints. The endpoints provide operations that that work on a set of stack calculators. Each calculator is identified by an arbitrary string and is created on first use of the identifier.

### Demo

A demo is available at https://calc.nutsweb.nl

### Endpoints

All endpoints are `GET` requests, in order to make it easy using the endpoints in a regular browser.
Success responses have an HTTP status code of `200`, error responses have a `500` status code. 

#### `/calc/:id/peek` 
- Returns stack[top].
- Returns `error: stack underflow` when the stack is empty.

#### `/calc/:id/push/<n>`
- Pushes a number onto the stack.
- Returns the new stack[top].
- Returns `error: invalid argument` when the value is non-numeric. 

#### `/calc/:id/pop`
- Returns the top from the stack and removes it.
- Returns `error: stack underflow` when the stack is empty.

#### `/calc/:id/add`
- Removes the top and top-1 from the stack and replaces it with stack[top-1]+stack[top].
- Returns the new stack[top].
- Returns `error: stack underflow` when the stack contains less than two elements.

#### `/calc/:id/subtract`
- Removes the top and top-1 from the stack and replaces it with stack[top-1]-stack[top].
- Returns the new stack[top].
- Returns `error: stack underflow` when the stack contains less than two elements.

#### `/calc/:id/multiply`
- Removes the top and top-1 from the stack and replaces it with stack[top-1]*stack[top].
- Returns the new stack[top].
- Returns `error: stack underflow` when the stack contains less than two elements.

#### `/calc/:id/divide`
- Removes the top and top-1 from the stack and replaces it with stack[top-1]/stack[top].
- Returns the new stack[top].
- Returns `error: stack underflow` when the stack contains less than two elements.
- Returns `error: devision by zero` when stack[top] is zero.

### Implementation details

The application implemented in PHP and makes use of the Lumen framework. It is a '*The stunningly fast micro-framework by Laravel*'.

The stack of each calculator is stored using the caching layer of the framework. This makes it possible to configure the cache driver to use e.g. the filesystem, Redis, Memcached, or even a regular database. This improves scalability.

The `app/Calculator.php` contains all logic and each method is unit tested.

All HTTP endpoints are defined in `routes/web.php`, which delegates to `app/Http/Controllers/CalculatorController.php`.
The controller retrieves the relevant calculator stack from the cache, delegates the calculations to the `Calculator` class and stores the stack afterwards.
The integration tests test the complete flow through the app.

### Suggestions for improvements
- A reset endpoint to clear a calculator.
- Make better use of the available HTTP methods, e.g. `GET` for requests that do no modify state and others for requests that do modify the state.
- An endpoint to view the entire stack of a calculator.
- Responses a common standard format, such as JSON or XML to make them better processable.
