
import React, { Component } from 'react';
import axios from 'axios';

class Users extends Component{
    constructor(){
        super();  
        this.state = {users:[]};  
    }    

    componentDidMount(){
        axios.get('/api/account').then(response => {
            this.setState({users: response.data.data});    
        })    
    }
    

    render(){
        let list;
        if(this.state.users.length == 0){
           list = <li></li>    
        }else{
            list = this.state.users.map(user=>(
                <li className="list-group-item">{user.username}</li>    
            ))
        }
        return(
            <ul className="list-group">
                {list}
            </ul>
        )    
    }
}

export default Users;
