import { ScrollArea, ScrollBar } from "@/components/ui/scroll-area";
import { AppLayout } from "@/layouts/app-layout";
import { PageProps, Space, SpaceColumn, Task } from "@/types";
import { DndContext, DragEndEvent } from "@dnd-kit/core";
import { router } from "@inertiajs/react";
import { TaskItem } from "./components/task-item";
import { TaskList } from "./components/task-list";

type Props = {
    space: Space;
};

export default function SpaceByIdPage(props: PageProps<Props>) {
    const handleDragEnd = (event: DragEndEvent) => {
        const task = event.active?.data.current?.task as Task;
        const column = event.over?.data.current?.column as SpaceColumn;
        if (task && column && column.id !== task.space_column_id) {
            const data = {
                ...task,
                space_column_id: column.id,
                status: column.status,
            } as any;
            router.patch(`/api/space/${task.space_id}/task/${task.id}`, data);
        }
    };

    return (
        <AppLayout>
            <DndContext onDragEnd={handleDragEnd}>
                <ScrollArea className="w-full max-w-[100vw]  whitespace-nowrap">
                    <div className="flex w-full mb-4 space-x-5">
                        {props.space?.columns?.map((column) => {
                            return (
                                <TaskList key={`column-${column.id}`} column={column}>
                                    {column?.tasks?.map((task) => {
                                        return (
                                            <TaskItem
                                                key={`task-${task.id}`}
                                                task={task}
                                            />
                                        );
                                    })}
                                </TaskList>
                            );
                        })}
                    </div>
                    <ScrollBar orientation="horizontal" />
                </ScrollArea>
            </DndContext>
        </AppLayout>
    );
}
