// UpdateUser.js
import React, { useState } from 'react';
import axios from 'axios';

function UpdateUser({ user, onUpdate }) {
    const [name, setName] = useState(user.name);
    const [email, setEmail] = useState(user.email);

    const handleSubmit = (e) => {
        e.preventDefault();
        axios.put(`http://localhost:8000/users/${user.id}`, { name, email })
            .then(response => {
                onUpdate(response.data);
            })
            .catch(error => {
                console.error('Error updating user:', error);
            });
    };

    return (
        <div>
            <h2>Update User</h2>
            <form onSubmit={handleSubmit}>
                <input type="text" placeholder="Name" value={name} onChange={(e) => setName(e.target.value)} />
                <input type="email" placeholder="Email" value={email} onChange={(e) => setEmail(e.target.value)} />
                <button type="submit">Update</button>
            </form>
        </div>
    );
}

export default UpdateUser;
