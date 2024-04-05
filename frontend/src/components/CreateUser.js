// CreateUser.js
import React, { useState } from 'react';
import axios from 'axios';

function CreateUser({ onUserCreated }) {
    const [name, setName] = useState('');
    const [email, setEmail] = useState('');

    const handleSubmit = (e) => {
        e.preventDefault();
        axios.post('http://localhost:8000/users', { name, email })
            .then(response => {
                onUserCreated(response.data);
                setName('');
                setEmail('');
            })
            .catch(error => {
                console.error('Error creating user:', error);
            });
    };

    return (
        <div>
            <h2>Create User</h2>
            <form onSubmit={handleSubmit}>
                <input type="text" placeholder="Name" value={name} onChange={(e) => setName(e.target.value)} />
                <input type="email" placeholder="Email" value={email} onChange={(e) => setEmail(e.target.value)} />
                <button type="submit">Create</button>
            </form>
        </div>
    );
}

export default CreateUser;
