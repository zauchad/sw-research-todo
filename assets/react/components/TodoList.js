import React, { useState, useEffect } from "react";
import { DragDropContext, Droppable, Draggable } from "react-beautiful-dnd";
import {Todo} from "./Todo";

const reorder = (list, startIndex, endIndex) => {
    const result = Array.from(list);
    const [removed] = result.splice(startIndex, 1);
    result.splice(endIndex, 0, removed);

    return result;
};

function TodoList({quotes}) {
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

        // const quotes = reorder(
        //     state.quotes,
        //     result.source.index,
        //     result.destination.index
        // );
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
                                            name={quote.name}
                                            innerRef={provided.innerRef}
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