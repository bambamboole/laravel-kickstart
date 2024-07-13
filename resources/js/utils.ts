import { usePage } from '@inertiajs/vue3';

export function hasProjectPermission(permission: string): boolean {
    const props = usePage().props;
    if (!props.auth.user) {
        return false;
    }
    if (!props.project) {
        return false;
    }
    return Object.values(
        props.project.members.find((member: any) => member.email === props.auth.user.email).role.permissions,
    ).includes(permission);
}
