// DeleteUser.js
import React from 'react';
import axios from 'axios';

function DeleteUser({ user, onDelete }) {
    const handleDelete = () => {
        axios.delete(`http://localhost:8000/users/${user.id}`)
            .then(() => {
                onDelete(user.id);
            })
            .catch(error => {
                console.error('Error deleting user:', error);
            });
    };

    return (
        <div>
            <h2>Delete User</h2>
            <p>Are you sure you want to delete {user.name}?</p>
            <button onClick={handleDelete}>Delete</button>
        </div>
    );
}

export default DeleteUser;
