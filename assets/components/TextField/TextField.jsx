import React,{useState} from 'react';

import './TextField.css';

const TextField = ({ name,selectedAmount,value,placeholder }) => {
  const [inputValue, setInputValue] = useState(null);


  const handleChange = (event) => {
    const value = event.target.value;
    selectedAmount(value); // Pass the updated value directly to the selectedAmount function
  };
  return (
    <div className='text-field'>
      <input type="text" id={name} name={name} value={value} placeholder={placeholder} className='rounded-textfield' onChange={handleChange}/>
    </div>
  );
};

export default TextField;
