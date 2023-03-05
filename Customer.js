
export class Customer{

   constructor(name, address,telephoneNo,id,reward) {  // Constructor
        this.name = name;
        this.id = id;
        this.address = address;
        this.telephoneNo = telephoneNo;     
        this.reward = reward;
    }

    getName(){return this.name;}
    getId(){return this.id;}
    getAddress(){return this.address;}
    getTelephoneNo(){return this.telephoneNo;}
    getReward(){return this.reward;}
   // updateReward(){}
   
   //cart

}



