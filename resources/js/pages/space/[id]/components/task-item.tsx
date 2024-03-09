import { cn } from "@/lib/utils";
import { Task } from "@/types";
import { useDraggable } from "@dnd-kit/core";

type TaskItemProps = {
    task: Task;
};

export const TaskItem = ({ task }: TaskItemProps) => {
    const { attributes, listeners, setNodeRef, transform } = useDraggable({
        id: task.id,
        data: { task },
    });

    const style = transform
        ? {
              transform: `translate3d(${transform.x}px, ${transform.y}px, 0)`,
              position: "fixed",
          }
        : { transform: "initial", position: "initial" };
    return (
        <div
            ref={setNodeRef}
            {...listeners}
            {...attributes}
            className={cn(
                "z-10 w-[300px] cursor-pointer p-4 rounded-lg border border-dashed hover:border-solid shadow",
                transform ? "bg-primary-foreground border-destructive-foreground" : "",
            )}
            style={style as React.CSSProperties}>
            <h3 className="text-lg font-bold">
                #{task.id} {task.title}
            </h3>
            <p>{task.description}</p>
        </div>
    );
};

export const TaskItemEmpty = () => {
    return <div className="p-4 rounded-lg border border-dashed shadow w-full h-20"></div>;
};
