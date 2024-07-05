class AdminKey{
    constructor(givenKey){
        this.givenKey=givenKey;
    }
    adminKey="1999";
    checkKey(){
        if(this.adminKey===this.givenKey){
            return true;
        }
        else{
            return false;
        }
    }
}
