import React from 'react';
import './TextField.css';

const TextField = ({ name }) => {
  return (
    <div className='text-field'>
      <input type="text" id={name} name={name} placeholder='Amount' className='rounded-textfield'/>
    </div>
  );
};

export default TextField;
