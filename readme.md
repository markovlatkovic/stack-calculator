## Stack Calculator

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
- Returns `error: invalid argument` when the stack contains less than two elements.

#### `/calc/:id/multiply`
- Removes the top and top-1 from the stack and replaces it with stack[top-1]*stack[top].
- Returns the new stack[top].
- Returns `error: invalid argument` when the stack contains less than two elements.

#### `/calc/:id/divide`
- Removes the top and top-1 from the stack and replaces it with stack[top-1]/stack[top].
- Returns the new stack[top].
- Returns `error: invalid argument` when the stack contains less than two elements.
- Returns `error: devision by zero` when stack[top] is zero.
