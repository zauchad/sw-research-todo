import React from 'react';
import { DragDropContext, Droppable, Draggable } from 'react-beautiful-dnd';
import axios from 'axios';
import { Todo } from './Todo';

function TodoList({ quotes, refreshHandler }) {
  function onDragEnd(result) {
    if (!result.destination) {
      return;
    }

    if (result.destination.index === result.source.index) {
      return;
    }

    axios.put('/api/todo/position', {
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
            {
                            quotes.map((quote, index) => (
                              <Draggable draggableId={quote.id} index={index} key={quote.id}>
                                {(draggableProvided) => (
                                  <Todo
                                    id={quote.id}
                                    name={quote.name}
                                    innerRef={draggableProvided.innerRef}
                                    refreshHandler={refreshHandler}
                                    {...draggableProvided.draggableProps}
                                    {...draggableProvided.dragHandleProps}
                                  />
                                )}
                              </Draggable>
                            ))
                        }
            {provided.placeholder}
          </div>
        )}
      </Droppable>
    </DragDropContext>
  );
}

export { TodoList };
