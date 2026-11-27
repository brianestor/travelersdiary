import { NextRequest, NextResponse } from "next/server";
import { STAFF_COOKIE } from "@/lib/staff";

export async function POST(request: NextRequest) {
  const response = NextResponse.redirect(new URL("/admin", request.url), 303);
  response.cookies.set(STAFF_COOKIE, "", { httpOnly: true, path: "/", maxAge: 0 });
  return response;
}
