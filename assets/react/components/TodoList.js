import React from "react";
import { DragDropContext, Droppable, Draggable } from "react-beautiful-dnd";
import axios from "axios";
import { Todo } from "./Todo";

function TodoList({ todos, refreshHandler }) {
  function onDragEnd(result) {
    if (!result.destination) {
      return;
    }

    if (result.destination.index === result.source.index) {
      return;
    }

    axios
      .put("/api/todo/position", {
        id: result.draggableId,
        position: result.destination.index,
      })
      .then(() => {
        refreshHandler();
      });
  }

  return (
    <DragDropContext onDragEnd={onDragEnd}>
      <Droppable droppableId="list">
        {(provided) => (
          <div ref={provided.innerRef} {...provided.droppableProps}>
            {todos.map((todo, index) => (
              <Draggable draggableId={todo.id} index={index} key={todo.id}>
                {(draggableProvided) => (
                  <Todo
                    id={todo.id}
                    name={todo.name}
                    innerRef={draggableProvided.innerRef}
                    refreshHandler={refreshHandler}
                    {...draggableProvided.draggableProps}
                    {...draggableProvided.dragHandleProps}
                  />
                )}
              </Draggable>
            ))}
            {provided.placeholder}
          </div>
        )}
      </Droppable>
    </DragDropContext>
  );
}

export { TodoList };
