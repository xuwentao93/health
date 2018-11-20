const _toString = Object.prototype.toString

export const toRawType = value => _toString.call(value).slice(8, -1) // 获取参数的数据类型。

function isObject (obj) { // 判断参数是否为对象且不为空（可以是空对象）。ps：
  return obj !== null && typeof obj === 'object' // typeof null is obj,typeof und is und,typeof {} is obj
}

export function looseEqual (a, b) { // 判断两个对象或者两个基本数据类型是否在模型上
  if (a === b) return true // 相等，基本数据类型转化成字符串比较，对象用遍历属性比较。
  const isObjectA = isObject(a)
  const isObjectB = isObject(b)
  if (isObjectA && isObjectB) {
    try {
      const isArrayA = Array.isArray(a)
      const isArrayB = Array.isArray(b)
      if (isArrayA && isArrayB) {
        return a.length === b.length && a.every((e, i) => {
          return looseEqual(e, b[i])
        })
      } else if (a instanceof Date && b instanceof Date) {
        return a.getTime() === b.getTime()
      } else if (!isArrayA && !isArrayB) {
        const keysA = Object.keys(a)
        const keysB = Object.keys(b)
        return keysA.length === keysB.length && keysA.every(key => {
          return looseEqual(a[key], b[key])
        })
      } else {
        /* istanbul ignore next */
        return false
      }
    } catch (e) {
      /* istanbul ignore next */
      return false
    }
  } else if (!isObjectA && !isObjectB) {
    return String(a) === String(b)
  } else {
    return false
  }
}
