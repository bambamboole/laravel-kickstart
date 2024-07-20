import { usePage } from '@inertiajs/vue3';
import { fromZonedTime, toZonedTime } from 'date-fns-tz';
import { formatDistanceToNow } from 'date-fns';

export function hasProjectPermission(permission: string | null | undefined): boolean {
    if (!permission) {
        return true;
    }
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

export function parseDate(utcDateString: string): Date {
    const date = fromZonedTime(utcDateString, 'UTC');
    const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    return toZonedTime(date, timezone);
}

export function diffForHumans(utcDateString: string): string {
    return formatDistanceToNow(parseDate(utcDateString));
}
