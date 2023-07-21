import React, { Component } from "react";
import ReactDom from "react-dom/client";
import "./styles/app.css";
import Footer from "./components/Footer/Footer";
import LoginForm from "./components/LoginForm/LogInForm";


class App extends Component {
  render() {
    return (
      <div className="body">
        <LoginForm/>
        <Footer />
      </div>
    );
  }
}



ReactDom.createRoot(document.getElementById("root")).render(<App />);

