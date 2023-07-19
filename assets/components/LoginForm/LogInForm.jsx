import React, { Fragment, useRef, useState } from 'react';
import { Button, TextField, Typography } from '@mui/material';
import { ReactDOM } from 'react';
import './LogInForm.css';

const LoginForm = () => {
  const emailRef = useRef(null);
  const passwordRef = useRef(null);
  const [emailError, setEmailError] = useState('');
  const [passwordError, setPasswordError] = useState('');

  const handleSubmit = (event) => {
    event.preventDefault();

    // Get the values from the refs
    const emailValue = emailRef.current.value;
    const passwordValue = passwordRef.current.value;

    // Validate email and password
    const isEmailValid = validateEmail(emailValue);
    const isPasswordValid = validatePassword(passwordValue);

    // Update error state based on validation results
    setEmailError(isEmailValid ? '' : 'Invalid email address');
    setPasswordError(isPasswordValid ? '' : 'Password is required');

    // If both email and password are valid, submit the form
    if (isEmailValid && isPasswordValid) {
      // Add your logic here for form submission
      console.log('Form submitted successfully!');
    }
  };

  const validateEmail = (email) => {
    // Basic email validation using a regular expression
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  };

  const validatePassword = (password) => {
    // Simple password validation (not empty)
    return password.trim() !== '';
  };

  return (
    <div className="form-container">
      <Typography variant="h5" component="h2" className="form-header">
        Log In to Continue
      </Typography>
      <form className='form-small-container' onSubmit={handleSubmit}>
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

        <Button type="submit" variant="contained" color="primary" className="form-button">
          Submit
        </Button>
      </form>
    </div>
  );
};

if (document.getElementById("login")) {
  console.log("eimai edw");
}

export default LoginForm;
