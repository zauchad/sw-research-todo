import React from "react";
import { DragDropContext, Droppable, Draggable } from "react-beautiful-dnd";
import {Todo} from "./Todo";
import axios from "axios";

function TodoList({quotes, refreshHandler}) {
    function onDragEnd(result) {
        console.log(
            result.source.index,
            result.destination.index,
        );

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
            .then(function (response) {
                refreshHandler();
                console.log('success', response);
            })
            .catch(function (error) {
                // handle error
                console.log('error', error);
            })
            .then(function () {

            });
    }

    return (
        <DragDropContext onDragEnd={onDragEnd}>
            <Droppable droppableId="list">
                {provided => (
                    <div ref={provided.innerRef} {...provided.droppableProps}>
                        {
                            quotes.map((quote, index) => (
                                <Draggable draggableId={quote.id} index={index} key={quote.id}>
                                    {provided => (
                                        <Todo
                                            id={quote.id}
                                            name={quote.name}
                                            innerRef={provided.innerRef}
                                            refreshHandler={refreshHandler}
                                            {...provided.draggableProps}
                                            {...provided.dragHandleProps}
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

export {TodoList};