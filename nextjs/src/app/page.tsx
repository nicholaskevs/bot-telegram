import { api } from "@/lib/api";

type Ping = { ok: boolean; time: string };

export default async function Home() {
  let ping: Ping | { error: string };
  try {
    ping = await api<Ping>("/ping", { cache: "no-store" });
  } catch (e) {
    ping = { error: e instanceof Error ? e.message : "unknown" };
  }

  return (
    <main className="mx-auto max-w-2xl p-8 font-sans">
      <h1 className="text-2xl font-semibold">Next.js + Laravel</h1>
      <p className="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
        Server-side fetched from{" "}
        <code className="rounded bg-zinc-100 px-1 dark:bg-zinc-900">/api/ping</code>
      </p>
      <pre className="mt-4 rounded bg-zinc-100 p-4 text-sm dark:bg-zinc-900">
        {JSON.stringify(ping, null, 2)}
      </pre>
    </main>
  );
}
