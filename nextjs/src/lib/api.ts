const INTERNAL = process.env.INTERNAL_API_URL ?? "http://nginx/api";
const PUBLIC = process.env.NEXT_PUBLIC_API_URL ?? "/api";

export const apiBase = () => (typeof window === "undefined" ? INTERNAL : PUBLIC);

export async function api<T>(path: string, init?: RequestInit): Promise<T> {
  const res = await fetch(`${apiBase()}${path}`, {
    credentials: "include",
    headers: { Accept: "application/json", ...(init?.headers ?? {}) },
    ...init,
  });
  if (!res.ok) throw new Error(`${res.status} ${res.statusText}`);
  return res.json() as Promise<T>;
}
