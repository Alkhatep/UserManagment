// UserList.js
import React from 'react';

function UserList({ users, onEditUser, onDeleteUser }) {
    return (
        <div>
            <h1>User List</h1>
            <ul>
                {users.map(user => (
                    <li key={user.id}>
                        {user.name} - {user.email}
                        <button onClick={() => onEditUser(user)}>Edit</button>
                    </li>
                ))}
            </ul>
        </div>
    );
}

export default UserList;
