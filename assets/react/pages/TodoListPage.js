import React from 'react';
import {TodoList} from "../components/TodoList";

const TodoListPage = () => {
    return (
        <div className="container-xxl py-4">
            <h2 className="mb-4">SW Research TODO list</h2>
            <div className="d-flex justify-content-end align-items-center mb-3">
                <button type="button" className="btn btn-success">Add</button>
            </div>

            <div>
                <TodoList />
            </div>
        </div>
    );
};

export {TodoListPage};