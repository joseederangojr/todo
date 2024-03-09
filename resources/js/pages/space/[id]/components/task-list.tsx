import { ScrollArea } from "@/components/ui/scroll-area";
import { SpaceColumn } from "@/types";
import { useDroppable } from "@dnd-kit/core";
import { TaskItemEmpty } from "./task-item";

type TaskListProps = {
    column: SpaceColumn;
};

export const TaskList = ({
    column,
    children,
}: React.PropsWithChildren<TaskListProps>) => {
    const { isOver, setNodeRef } = useDroppable({
        id: column.id,
        data: { column },
    });

    return (
        <div
            ref={setNodeRef}
            className="flex flex-col flex-shrink-0 p-4 border rounded-lg h-[80vh]">
            <h2 className="text-xl font-bold">{column.name}</h2>
            <ScrollArea className="w-full h-full mt-4 !overflow-[unset]">
                <div className="flex flex-col flex-1 space-y-4 mr-4">
                    <div className="w-[300px]" />
                    {isOver ? <TaskItemEmpty /> : undefined}
                    {children}
                </div>
            </ScrollArea>
        </div>
    );
};
