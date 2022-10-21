import React, { useState, useEffect } from "react";
import { Toaster } from "react-hot-toast";
import axios from "axios";
import { TodoList } from "../components/TodoList";
import { CreateTodoButton } from "../components/CreateTodoButton";

function TodoListPage() {
  const [state, setState] = useState({ todos: [] });

  const refreshTodos = () => {
    axios.get("/api/todos").then((response) => {
      const todos = response.data;

      todos.sort((a, b) => a.position > b.position);

      setState({
        todos,
      });
    });
  };

  useEffect(() => {
    refreshTodos();
  }, []);

  return (
    <div className="container-xxl py-4">
      <Toaster />
      <h2 className="mb-4">SW Research TODO list</h2>
      <CreateTodoButton refreshHandler={refreshTodos} />
      <div>
        <TodoList todos={state.todos} refreshHandler={refreshTodos} />
      </div>
    </div>
  );
}

export { TodoListPage };
