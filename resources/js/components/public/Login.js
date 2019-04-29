
import React, { Component } from 'react';
import axios from 'axios';

class Login extends Component{
    constructor(){
        super();
        this.state = {password: "", username:"", exists:false};
    }

    handleUsername(e){
        this.setState({username:e.target.value});
    }

    handlePassword(e){
        this.setState({password:e.target.value});
    }


    login(e){
        e.preventDefault();

	axios.post('/api/login',{
            'username' : this.state.username,
            'password' : this.state.password
        })
	    .then(response =>{
            if(response.status == 200){
	    	    this.props.history.push({
                    pathname: "/applicant",
                    state: {
                        account_id : response.data.id    
                    }    
                });
            }
	    })

    }

        
    
    render(){
        return(
            <div className="row">
		            <div className="col mt-4">
		<h5 className="font-weight-bold">Login</h5>
                <form>
                    <div className="form-group">
                        <label>Username</label>
                        <input className="form-control" type="text" id="username" name="username" onChange={(e)=>(this.handleUsername(e))} value={this.state.username}/>
                    </div>

                    <div className="form-group">
                        <label>Password</label>
                        <input className="form-control" type="password" id="password" name="password" onChange={(e)=>(this.handlePassword(e))} value={this.state.password}/>
                    </div>

                    <button type="submit" className="btn btn-primary" onClick={(e) => (this.login(e))}>Login</button>
                </form>
		</div>
            </div>
        )
    }
}

export default Login;
