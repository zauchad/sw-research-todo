import React from 'react';
import { UpdateTodoNameButton } from './UpdateTodoNameButton';
import { RemoveTodoButton } from './RemoveTodoButton';

function Todo(props) {
  return (
    <div ref={props.innerRef} className="card mb-3 m-auto" {...props}>
      <div className="card-body d-flex justify-content-between align-items-center">
        <h5 className="card-title d-inline-block me-2 w-75">{props.name}</h5>
        <div>
          <UpdateTodoNameButton id={props.id} refreshHandler={props.refreshHandler} />
          <RemoveTodoButton id={props.id} refreshHandler={props.refreshHandler} />
        </div>
      </div>
    </div>
  );
}

export { Todo };
