import React from 'react';
import {Todo} from "./Todo";

const TodoList = () => {
    return [1,2,3,5].map(() => <Todo name="TODO"/>)
};

export {TodoList};