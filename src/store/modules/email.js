const email = {
    state:{
        number:0
    },
    getters:{
        number:state=>state.number
    },
    mutations:{
        changeNumber(number){
            this.number = number
        }
    }
}

export default email