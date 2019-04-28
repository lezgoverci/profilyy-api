import React, { Component } from 'react';
import axios from 'axios';

class Register extends Component{
    constructor(){
        super();
        this.state = {password: "", retypePassword:"", username:"", passwordMatch:null, accountExists:false};
    }

    handleUsername(e){
        this.setState({username:e.target.value});
    }

    handlePassword(e){
        this.setState({password:e.target.value});
    }

    handleRetypePassword(e){
        this.setState({retypePassword:e.target.value},()=>{
        	if(this.state.password !== this.state.retypePassword){
       		     this.setState({passwordMatch:false});
      		  }else{
      		      this.setState({passwordMatch:true});
      		  }
	
	});
    }

    handleRegister(e){
        e.preventDefault();

        if(this.state.password == this.state.retypePassword){
            if(this.state.password !== "" && this.state.retypePassword !== ""){
	            axios.post('/api/account',{
                    'username': this.state.username,
                    'password' : this.state.password
                })
                .then(response => {
                    if(response.status == 201){
                        this.props.history.push("/login");
                    }else if(response.message === "Account already exists"){
                        
                        this.setState({accountExists: true});
                    }
                })
                .catch(error =>{
                    console.log(error);
                })
                
            }
        }

    }

        
    
    render(){
        return(
            <div className="row">
		            <div className="col mt-4">
                    {(this.state.accountExists == false) ? "" : 
                        <div className="alert alert-danger" role="alert">
                            A simple danger alert—check it out!
                        </div>
                    }
		<h5 className="font-weight-bold">Register as applicant</h5>
                <form>
                    <div className="form-group">
                        <label>Username</label>
                        <input className="form-control" type="text" id="username" name="username" onChange={(e)=>(this.handleUsername(e))} value={this.state.username}/>
                    </div>

                    <div className="form-group">
                        <label>Password</label>
                        <input className="form-control" type="password" id="password" name="password" onChange={(e)=>(this.handlePassword(e))} value={this.state.password}/>
                    </div>

                    <div className="form-group">
                        <label>Retype Password</label>
                        <input className={`form-control ${(this.state.passwordMatch == null) ? "" : (this.state.passwordMatch == false) ? "is-invalid" : "is-valid"}`} type="password" id="retype-password" onChange={(e)=>(this.handleRetypePassword(e))} value={this.state.retypePassword} />
                        <div className={`${(this.state.passwordMatch == false) ? "invalid-feedback": "valid-feedback"}`} >
                            {(this.state.passwordMatch == false) ? "Passwords do not match": "Passwords match"}
                        </div>
                    </div>
                    <button type="submit" className="btn btn-primary" onClick={(e) => (this.handleRegister(e))}>Submit</button>
                </form>
		</div>
            </div>
        )
    }
}

export default Register;
