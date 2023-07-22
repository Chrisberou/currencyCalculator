import React, { useRef, useState } from "react";
import axios from "axios"; // Import Axios library
import { Button, TextField, Typography } from "@mui/material";
import "./LogInForm.css";

const LoginForm = () => {
  const emailRef = useRef(null);
  const passwordRef = useRef(null);
  const [emailError, setEmailError] = useState("");
  const [passwordError, setPasswordError] = useState("");
  

  const handleSubmit = async (event) => {
    event.preventDefault();

    // Get the values from the refs
    const emailValue = emailRef.current.value;
    const passwordValue = passwordRef.current.value;

    // Validate email and password
    const isEmailValid = validateEmail(emailValue);
    const isPasswordValid = validatePassword(passwordValue);

    // Update error state based on validation results
    setEmailError(isEmailValid ? "" : "Invalid email address");
    setPasswordError(isPasswordValid ? "" : "Password is required");

    // If both email and password are valid, submit the form
    if (isEmailValid && isPasswordValid) {
      try {
        // Send login credentials to the Symfony backend using Axios
        const response = await axios.post("/", {
          email: emailValue,
          password: passwordValue,
        });

        if (response.data.success) {
      // Successfully logged in, redirect to /main or handle as needed.
          window.location.href = "/main";
        } else {
          // Handle login failure (e.g., show an error message).
          console.log("Login failed.");
        }
      } catch (error) {
        // Handle any errors that might occur during the login process.
        console.error("Error during login:", error);
      }
    }
  };

  const validateEmail = (email) => {
    // Basic email validation using a regular expression
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  };

  const validatePassword = (password) => {
    // Simple password validation (not empty)
    return password.trim() !== "";
  };

  return (
    <div className="form-container">
      <Typography variant="h5" component="h2" className="form-header">
        Log In to Continue
      </Typography>
      <form
        className="form-small-container"
        onSubmit={handleSubmit}
        method="post"
      >
        <TextField
          label="Email"
          type="email"
          variant="outlined"
          inputRef={emailRef}
          error={!!emailError}
          helperText={emailError}
          fullWidth
          required
          className="form-field"
        />

        <TextField
          label="Password"
          type="password"
          variant="outlined"
          inputRef={passwordRef}
          error={!!passwordError}
          helperText={passwordError}
          fullWidth
          required
          className="form-field"
        />

        <Button
          type="submit"
          variant="contained"
          color="primary"
          className="form-button"
        >
          Submit
        </Button>
      </form>
    </div>
  );
};

export default LoginForm;
