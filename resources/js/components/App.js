
import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { BrowserRouter, Route, Switch } from 'react-router-dom'

import Register from "./public/Register";
import Login from "./public/Login";
import Users from "./public/Users";

import Profile from "./applicant/Profile";


function Public({match}){
  return(
    <div className="container">
      <Switch>
        <Route path={`${match.path}register`} component={Register}/>
       	<Route path={`${match.path}login`} component={Login}/>
       	<Route path={`${match.path}`} component={Users}/>
        <Route path="*" component={() => "Page not found"} />
      </Switch>
    </div>
  )
}

function Admin({match}){
  return(
    <div>Adminn</div>
  )
}

function Applicant({match}){
  return(
    <div className="container">
      <Switch>
       	<Route path={`${match.path}`} component={Profile}/>
        <Route path="*" component={() => "Page not found"} />
      </Switch>
    </div>
  )
}

function Hr({match}){
  return(
    <div>HR</div>
  )
}

class App extends Component {
  render () {
    return (
      <BrowserRouter>
        <div id="app-component">
          <Switch>
            <Route path="/hr" component={Hr} />
            <Route path="/applicant" component={Applicant} />
            <Route path="/admin" component={Admin} />
            <Route path="/" component={Public} />
            <Route path="*" component={() => "Page not found"} />
          </Switch>
        </div>
      </BrowserRouter>
    )
  }
}


ReactDOM.render(<App />, document.getElementById('app'))
