function foo(a, b) {
  if (a === b) {
    return true;
  } else if (typeof a !== 'object' || typeof b !== 'object') {
    return false;
  }
  const aKeys = Object.keys(a);
  const bKeys = Object.keys(b);
  if (aKeys.length !== bKeys.length) {
    return false;
  }
  for (let i = 0; i < aKeys.length; i++) {
    const key = aKeys[i];
    if (!b.hasOwnProperty(key) || !foo(a[key], b[key])) {
      return false;
    }
  }
  return true;
}

const obj1 = { a: 1, b: 2 };
const obj2 = { a: 1, b: 2 };
console.log(foo(obj1, obj2)); // true

const obj3 = { a: 1, b: { c: 3 } };
const obj4 = { a: 1, b: { c: 3 } };
console.log(foo(obj3, obj4)); // true

const obj5 = { a: 1, b: { c: 3 } };
const obj6 = { a: 1, b: { c: 4 } };
console.log(foo(obj5, obj6)); // false

const obj7 = { a: 1, b: { c: 3, d: 4 } };
const obj8 = { a: 1, b: { c: 3 } };
console.log(foo(obj7, obj8)); // false