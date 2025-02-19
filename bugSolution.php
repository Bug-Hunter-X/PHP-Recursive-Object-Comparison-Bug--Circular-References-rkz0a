function foo(a, b) {
  // Check for circular references using weak maps
  const visited = new WeakMap();

  function compare(a, b) {
    if (a === b) {
      return true;
    }
    if (typeof a !== 'object' || typeof b !== 'object' || a === null || b === null) {
      return false;
    }

    if (visited.has(a) || visited.has(b)) {
      return false; // Circular reference detected
    }
    visited.set(a, true);
    visited.set(b, true);

    const aKeys = Object.keys(a);
    const bKeys = Object.keys(b);
    if (aKeys.length !== bKeys.length) {
      return false;
    }
    for (let i = 0; i < aKeys.length; i++) {
      const key = aKeys[i];
      if (!b.hasOwnProperty(key) || !compare(a[key], b[key])) {
        return false;
      }
    }
    return true;
  }

  return compare(a, b);
}

// Example usage with circular references
const obj1 = {};
obj1.self = obj1;
const obj2 = {};
obj2.self = obj2;
console.log(foo(obj1, obj2)); // false (correctly handles circular refs)

const obj3 = { a: 1, b: { c: 3 } };
const obj4 = { a: 1, b: { c: 3 } };
console.log(foo(obj3, obj4)); // true

const obj5 = { a: 1, b: { c: 3 } };
const obj6 = { a: 1, b: { c: 4 } };
console.log(foo(obj5, obj6)); // false

const obj7 = { a: 1, b: { c: 3, d: 4 } };
const obj8 = { a: 1, b: { c: 3 } };
console.log(foo(obj7, obj8)); // false