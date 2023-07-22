// AuthContext.js
import React, { createContext, useState } from 'react';
import CurrencyCalculator from '../components/CurrencyCalculator/CurrencyCalculator';
import LoginForm from '../components/LoginForm/LogInForm';


const AuthContext = createContext();

const AuthProvider = ({ children }) => {
  const [isAdmin, setIsAdmin] = useState(0);

  return (
    <AuthContext.Provider value={{ isAdmin, setIsAdmin }}>
      {children}
    </AuthContext.Provider>
  );
};

export { AuthContext, AuthProvider };
