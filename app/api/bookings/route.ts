import { createBooking, ReservationError } from "@/lib/bookings";

export async function POST(request: Request) {
  let payload: unknown;
  try {
    payload = await request.json();
  } catch {
    return Response.json({ error: "Send the reservation as JSON." }, { status: 400 });
  }

  try {
    const booking = await createBooking(payload);
    return Response.json({ reference: booking.reference });
  } catch (error) {
    if (error instanceof ReservationError) {
      return Response.json({ error: error.message }, { status: 400 });
    }
    console.error(error);
    return Response.json({ error: "The desk could not save this reservation." }, { status: 500 });
  }
}
