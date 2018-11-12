//remove删除数组的第一个指定值，第一个参数是数组，第二个是值，没有的话就向数组添加该项，返回修改后的数组。
export const remove = (array, value) => {
    const index = array.indexOf(value)
    if (index != -1) {
        array.splice(index, 1)
    }
    else if (index == -1) {
        array.push(value)
    }
    return array;
}

//返回数据由数组变成对象,因为直接改变了原数组，所以无需返回也可以。

export const arrToObj = (array, ...args) => {
    array.forEach((item, index) => {
        const obj = {}
        item.forEach((citem, cindex) => {
            obj[args[cindex]] = citem
        })
        array[index] = obj
    })
    return array;
}

/**
 * @param {这个页面只有上面的代码有用 下面的代码只是用于学习数组的}
 */

//去重
export const unDuplicate = array => {
    return [...new Set(array)]
}

//移除所有指定值
export const removeAll = (array, value) => {
    array.forEach((item, index) => {
        if (item == value) array.splice(index, 1)
    })
}


//贪心算法中的一个例子。
export const greedy = array => {
    let sum = 0;
    for (let i = 0; i < array.length; i++) {
        if ((i + array[i] + 1) >= array.length) {
            sum++;  //当能跳到最后一个的时候，跳出循环。
            break;
        }
        let end = array[i + 1]  //用于判断应该跳到哪一个。
        let jump = i  //跳完以后修改i的值。
        for (let j = 0; j < array[i]; j++) {
            if ((array[i + j + 1] + j) >= end) { //下标加值最大，就跳到对应项。
                end = array[i + j + 1] + j
                jump = i + j
            }
        }
        sum++;
        i = jump;
    }
    return sum;
}

//两个已经排序好的数组，从他们当中筛选较小项添加到新的数组。
export const merge = (array1, array2) => {
    const array = []
    const length = array1.length + array2.length
    array1.push(Infinity)
    array2.push(Infinity)
    for (let i = 0; i < length; i++) {
        if (array1[0] >= array2[0]) {
            array.push(array2[0])
            array2.shift()
        }
        else if (array1[0] <= array2[0]) {
            array.push(array1[0])
            array1.shift()
        }
    }
    return array
}