import { ReservationError, saveMessage } from "@/lib/bookings";

export async function POST(request: Request) {
  let payload: unknown;
  try {
    payload = await request.json();
  } catch {
    return Response.json({ error: "Send the note as JSON." }, { status: 400 });
  }

  try {
    await saveMessage(payload);
    return Response.json({ ok: true });
  } catch (error) {
    if (error instanceof ReservationError) {
      return Response.json({ error: error.message }, { status: 400 });
    }
    console.error(error);
    return Response.json({ error: "The desk could not save this note." }, { status: 500 });
  }
}
