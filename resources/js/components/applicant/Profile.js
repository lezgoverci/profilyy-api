
import React, { Component } from 'react';
import axios from 'axios';

class Profile extends Component{
    constructor(){
        super();
        this.state = {
            profile: null, 
            id: null, 
            fname: "",
            lname: "",
            address: "",
            email: "",
            phone: "",
            gender: ""
        };
    }
    componentDidMount(){
        this.setState({id: this.props.location.state.account_id});
        
        axios.get('/api/user',{
            'id' : this.props.location.state.account_id    
        }).then(response =>{
            this.setState({profile: response.data});    
        })
    }

    handleChange(e){
        e.preventDefault();
        this.setState({
            [e.target.name] : e.target.value    
        })
    }

    createProfile(e){
        e.preventDefault();
        axios.post('/api/user',{
            'fname' : this.state.fname,
            'lname' : this.state.lname,
            'address' : this.state.address,
            'email' : this.state.email,
            'phone' : this.state.phone,
            'gender' : this.state.gender,
            'account_id': this.state.id
        }).then(response => {
            if(response.data.data.id != null){
                
                this.props.history.push("/");    
            }    
        });
    }

    render(){
        let loadProfile;
        if(this.state.profile == null){
            loadProfile = 
                <form>
                    <h5 className="font-weight-bold">Create your profile</h5>
                    <div className="form-group">
                        <label>First Name</label>
                        <input className="form-control" type="text" id="fname" name="fname" onChange={(e)=>(this.handleChange(e))} value={this.state.fname} />
                    </div>
                    <div className="form-group">
                        <label>Last Name</label>
                        <input className="form-control" type="text" id="lname" name="lname" onChange={(e)=>(this.handleChange(e))} value={this.state.lname}/>
                    </div>
                    <div className="form-group">
                        <label>Address</label>
                        <input className="form-control" type="text" id="address" name="address" onChange={(e)=>(this.handleChange(e))} value={this.state.address}/>
                    </div>
                    <div className="form-group">
                        <label>Email</label>
                        <input className="form-control" type="text" id="email" name="email" onChange={(e)=>(this.handleChange(e))} value={this.state.email}/>
                    </div>
                    <div className="form-group">
                        <label>Phone</label>
                        <input className="form-control" type="text" id="phone" name="phone" onChange={(e)=>(this.handleChange(e))} value={this.state.phone}/>
                    </div>
                    <div className="form-group">
                        <label>Gender</label>
                        <select className="form-control" id="gender" name="gender" onChange={(e)=>(this.handleChange(e))} value={this.state.gender}>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <button type="submit" className="btn btn-primary" onClick={(e) => (this.createProfile(e))}>Submit</button>
                </form>
        }
        else{
            loadProfile = <h1>Naay Profile</h1>    
        }
        return(
            <div className="row">
                <div className="col mt-4">
                   {loadProfile} 
                </div>
            </div>
        )
    }

}

export default Profile;
